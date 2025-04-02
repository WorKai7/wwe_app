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