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


export const createBelt = async (req: Request, res: Response): Promise<void> => {

    try {

        const { name } = req.body;

        if (!name) {

            res.status(400).json({ error: "Le champ 'name' est requis" });
            return;

        }

        const newBelt = await prisma.belt.create({
            data: { name }
        });

        res.status(201).json(newBelt);

    } catch (error) {

        console.error("Erreur createBelt :", error);
        res.status(500).json({ error: "Erreur interne, veuillez réessayer plus tard" });

    }

};


export const updateBelt = async (req: Request, res: Response): Promise<void> => {

    try {

        const { id } = req.params;
        const { name } = req.body;
        const beltId = Number(id);

        if (isNaN(beltId)) {

            res.status(400).json({ error: "L'id fourni n'est pas valide" });
            return;

        }

        if (!name) {

            res.status(400).json({ error: "Le champ 'name' est requis" });
            return;

        }

        const updatedBelt = await prisma.belt.update({
            where: { id: beltId },
            data: { name }
        });

        res.status(200).json(updatedBelt);

    } catch (error) {

        console.error("Erreur updateBelt :", error);
        
        if (error instanceof Error && error.message.includes("RecordNotFound")) {
            res.status(404).json({ error: "Cette belt n'existe pas" });
        } else {
            res.status(500).json({ error: "Erreur interne, veuillez réessayer plus tard" });
        }

    }

};


export const deleteBelt = async (req: Request, res: Response): Promise<void> => {

    try {

        const { id } = req.params;
        const beltId = Number(id);

        if (isNaN(beltId)) {

            res.status(400).json({ error: "L'id fourni n'est pas valide" });
            return;

        }

        await prisma.belt.delete({ where: { id: beltId } });

        res.status(204).end();

    } catch (error) {

        console.error("Erreur deleteBelt :", error);
        
        if (error instanceof Error && error.message.includes("RecordNotFound")) {
            res.status(404).json({ error: "Cette belt n'existe pas" });
        } else {
            res.status(500).json({ error: "Erreur interne, veuillez réessayer plus tard" });
        }

    }

};