import { Request, Response } from "express";
import prisma from "../client";


export const getAllMatchTypes = async (req: Request, res: Response): Promise<void> => {

    try {

        const matchTypes = await prisma.matchType.findMany();
        res.status(200).json(matchTypes);

    } catch (error) {

        console.error("Erreur getAllMatchTypes :", error);
        res.status(500).json({ error: "Erreur interne, veuillez réessayer plus tard" });

    }

};


export const getMatchTypeById = async (req: Request, res: Response): Promise<void> => {

    try {

        const { id } = req.params;
        const matchTypeId = Number(id);

        if (isNaN(matchTypeId)) {

            res.status(400).json({ error: "L'id fourni n'est pas valide" });
            return;

        }

        const matchType = await prisma.matchType.findUnique({ where: { id: matchTypeId } });

        if (!matchType) {

            res.status(404).json({ error: "Ce match type n'existe pas" });
            return;

        }

        res.status(200).json(matchType);

    } catch (error) {

        console.error("Erreur getMatchTypeById :", error);
        res.status(500).json({ error: "Erreur interne, veuillez réessayer plus tard" });

    }

};