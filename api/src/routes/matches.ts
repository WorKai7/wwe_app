import { Request, Response } from "express";
import prisma from "../client";


export const getAllMatches = async (req: Request, res: Response): Promise<void> => {

    try {

        const matches = await prisma.match.findMany();
        res.status(200).json(matches);

    } catch (error) {

        console.error("Erreur getAllMatches :", error);
        res.status(500).json({ error: "Erreur interne, veuillez réessayer plus tard" });

    }

};


export const getMatchById = async (req: Request, res: Response): Promise<void> => {

    try {

        const { id } = req.params;
        const matchId = Number(id);

        if (isNaN(matchId)) {

            res.status(400).json({ error: "L'id fourni n'est pas valide" });
            return;

        }

        const match = await prisma.match.findUnique({ where: { id: matchId } });

        if (!match) {

            res.status(404).json({ error: "Ce match n'existe pas" });
            return;

        }

        res.status(200).json(match);

    } catch (error) {

        console.error("Erreur getMatchById :", error);
        res.status(500).json({ error: "Erreur interne, veuillez réessayer plus tard" });

    }

};