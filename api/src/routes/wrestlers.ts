import { Request, Response } from "express";
import prisma from "../client";


export const getAllWrestlers = async (req: Request, res: Response): Promise<void> => {

    try {

        const wrestlers = await prisma.wrestler.findMany();
        res.status(200).json(wrestlers);

    } catch (error) {

        console.error("Erreur getAllWrestlers :", error);
        res.status(500).json({ error: "Erreur interne, veuillez réessayer plus tard" });

    }

};


export const getWrestlerById = async (req: Request, res: Response): Promise<void> => {

    try {

        const { id } = req.params;
        const wrestlerId = Number(id);

        if (isNaN(wrestlerId)) {

            res.status(400).json({ error: "L'id fourni n'est pas valide" });
            return;

        }

        const wrestler = await prisma.wrestler.findUnique({ where: { id: wrestlerId } });

        if (!wrestler) {

            res.status(404).json({ error: "Ce wrestler n'existe pas" });
            return;

        }

        res.status(200).json(wrestler);

    } catch (error) {

        console.error("Erreur getWrestlerById :", error);
        res.status(500).json({ error: "Erreur interne, veuillez réessayer plus tard" });

    }

};