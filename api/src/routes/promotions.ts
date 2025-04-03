import { Request, Response } from "express";
import prisma from "../client";


export const getAllPromotions = async (req: Request, res: Response): Promise<void> => {

    try {

        const promotions = await prisma.promotion.findMany();
        res.status(200).json(promotions);

    } catch (error) {

        console.error("Erreur getAllPromotions :", error);
        res.status(500).json({ error: "Erreur interne, veuillez réessayer plus tard" });

    }

};


export const getPromotionById = async (req: Request, res: Response): Promise<void> => {

    try {

        const { id } = req.params;
        const promotionId = Number(id);

        if (isNaN(promotionId)) {

            res.status(400).json({ error: "L'id fourni n'est pas valide" });
            return;

        }

        const promotion = await prisma.promotion.findUnique({ where: { id: promotionId } });

        if (!promotion) {

            res.status(404).json({ error: "Cette promotion n'existe pas" });
            return;

        }

        res.status(200).json(promotion);

    } catch (error) {

        console.error("Erreur getPromotionById :", error);
        res.status(500).json({ error: "Erreur interne, veuillez réessayer plus tard" });

    }

};


export const createPromotion = async (req: Request, res: Response): Promise<void> => {

    try {

        const { name } = req.body;

        if (!name) {

            res.status(400).json({ error: "Le champ 'name' est requis" });
            return;

        }

        const newPromotion = await prisma.promotion.create({
            data: { name }
        });

        res.status(201).json(newPromotion);

    } catch (error) {

        console.error("Erreur createPromotion :", error);
        res.status(500).json({ error: "Erreur interne, veuillez réessayer plus tard" });

    }

};


export const updatePromotion = async (req: Request, res: Response): Promise<void> => {

    try {

        const { id } = req.params;
        const { name } = req.body;
        const promotionId = Number(id);

        if (isNaN(promotionId)) {

            res.status(400).json({ error: "L'id fourni n'est pas valide" });
            return;

        }

        if (!name) {

            res.status(400).json({ error: "Le champ 'name' est requis" });
            return;

        }

        const updatedPromotion = await prisma.promotion.update({
            where: { id: promotionId },
            data: { name }
        });

        res.status(200).json(updatedPromotion);

    } catch (error) {

        console.error("Erreur updatePromotion :", error);
        
        if (error instanceof Error && error.message.includes("RecordNotFound")) {
            res.status(404).json({ error: "Cette promotion n'existe pas" });
        } else {
            res.status(500).json({ error: "Erreur interne, veuillez réessayer plus tard" });
        }

    }

};


export const deletePromotion = async (req: Request, res: Response): Promise<void> => {

    try {

        const { id } = req.params;
        const promotionId = Number(id);

        if (isNaN(promotionId)) {

            res.status(400).json({ error: "L'id fourni n'est pas valide" });
            return;

        }

        await prisma.promotion.delete({ where: { id: promotionId } });

        res.status(204).end();

    } catch (error: any) {

        console.error("Erreur deletePromotion :", error);
        
        if (error instanceof Error && error.message.includes("RecordNotFound")) {
            res.status(404).json({ error: "Cette promotion n'existe pas" });
        } else if (error.code === "P2003") {
            res.status(400).json({ error: "Impossible de supprimer cette promotion car elle est référencée par d'autres enregistrements" });
        } else {
            res.status(500).json({ error: "Erreur interne, veuillez réessayer plus tard" });
        }

    }

};