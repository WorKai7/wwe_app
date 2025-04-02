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