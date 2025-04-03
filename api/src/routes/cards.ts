import { Request, Response } from "express";
import prisma from "../client";


export const getAllCards = async (req: Request, res: Response): Promise<void> => {

    try {

        const cards = await prisma.card.findMany();
        res.status(200).json(cards);

    } catch (error) {

        console.error("Erreur getAllCards :", error);
        res.status(500).json({ error: "Erreur interne, veuillez réessayer plus tard" });

    }

};


export const getCardById = async (req: Request, res: Response): Promise<void> => {

    try {

        const { id } = req.params;
        const cardId = Number(id);

        if (isNaN(cardId)) {

            res.status(400).json({ error: "L'id fourni n'est pas valide" });
            return;

        }

        const card = await prisma.card.findUnique({ where: { id: cardId } });

        if (!card) {

            res.status(404).json({ error: "Cette card n'existe pas" });
            return;

        }

        res.status(200).json(card);

    } catch (error) {

        console.error("Erreur getCardById :", error);
        res.status(500).json({ error: "Erreur interne, veuillez réessayer plus tard" });

    }

};


export const createCard = async (req: Request, res: Response): Promise<void> => {

    try {

        const { table_id, location_id, promotion_id, event_date, event_id, url, info_html, match_html } = req.body;

        const newCard = await prisma.card.create({
            data: {
                table_id,
                location_id,
                promotion_id,
                event_date: event_date ? new Date(event_date) : null,
                event_id,
                url,
                info_html,
                match_html
            }
        });

        res.status(201).json(newCard);

    } catch (error) {

        console.error("Erreur createCard :", error);
        res.status(500).json({ error: "Erreur interne, veuillez réessayer plus tard" });

    }

};


export const updateCard = async (req: Request, res: Response): Promise<void> => {

    try {

        const { id } = req.params;
        const { table_id, location_id, promotion_id, event_date, event_id, url, info_html, match_html } = req.body;
        const cardId = Number(id);

        if (isNaN(cardId)) {

            res.status(400).json({ error: "L'id fourni n'est pas valide" });
            return;

        }

        const updatedCard = await prisma.card.update({
            where: { id: cardId },
            data: {
                table_id,
                location_id,
                promotion_id,
                event_date: event_date ? new Date(event_date) : null,
                event_id,
                url,
                info_html,
                match_html
            }
        });

        res.status(200).json(updatedCard);

    } catch (error) {

        console.error("Erreur updateCard :", error);
        
        if (error instanceof Error && error.message.includes("RecordNotFound")) {
            res.status(404).json({ error: "Cette card n'existe pas" });
        } else {
            res.status(500).json({ error: "Erreur interne, veuillez réessayer plus tard" });
        }

    }

};


export const deleteCard = async (req: Request, res: Response): Promise<void> => {

    try {

        const { id } = req.params;
        const cardId = Number(id);

        if (isNaN(cardId)) {

            res.status(400).json({ error: "L'id fourni n'est pas valide" });
            return;

        }

        await prisma.card.delete({ where: { id: cardId } });

        res.status(204).end();

    } catch (error) {

        console.error("Erreur deleteCard :", error);
        
        if (error instanceof Error && error.message.includes("RecordNotFound")) {
            res.status(404).json({ error: "Cette card n'existe pas" });
        } else {
            res.status(500).json({ error: "Erreur interne, veuillez réessayer plus tard" });
        }

    }

};