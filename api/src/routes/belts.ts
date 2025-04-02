import { Request, Response } from "express";
import prisma from "../client";


export const getAllBelts = async (req: Request, res: Response): Promise<void> => {

    try {

        const belts = await prisma.belt.findMany();
        res.status(200).json(belts);

    } catch (error) {

        console.error("Erreur getAllBelts :", error);
        res.status(500).json({ error: "Erreur interne, veuillez réessayer plus tard" });

    }

};


export const getBeltById = async (req: Request, res: Response): Promise<void> => {

    try {

        const { id } = req.params;
        const beltId = Number(id);

        if (isNaN(beltId)) {

            res.status(400).json({ error: "L'id fourni n'est pas valide" });
            return;

        }

        const belt = await prisma.belt.findUnique({ where: { id: beltId } });

        if (!belt) {

            res.status(404).json({ error: "Cette belt n'existe pas" });
            return;

        }

        res.status(200).json(belt);

    } catch (error) {

        console.error("Erreur getBeltById :", error);
        res.status(500).json({ error: "Erreur interne, veuillez réessayer plus tard" });

    }

};