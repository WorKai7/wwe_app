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


export const createWrestler = async (req: Request, res: Response): Promise<void> => {

    try {

        const { name } = req.body;

        if (!name) {

            res.status(400).json({ error: "Le champ 'name' est requis" });
            return;

        }

        const newWrestler = await prisma.wrestler.create({
            data: { name }
        });

        res.status(201).json(newWrestler);

    } catch (error) {

        console.error("Erreur createWrestler :", error);
        res.status(500).json({ error: "Erreur interne, veuillez réessayer plus tard" });

    }

};


export const updateWrestler = async (req: Request, res: Response): Promise<void> => {

    try {

        const { id } = req.params;
        const { name } = req.body;
        const wrestlerId = Number(id);

        if (isNaN(wrestlerId)) {

            res.status(400).json({ error: "L'id fourni n'est pas valide" });
            return;

        }

        if (!name) {

            res.status(400).json({ error: "Le champ 'name' est requis" });
            return;

        }

        const updatedWrestler = await prisma.wrestler.update({
            where: { id: wrestlerId },
            data: { name }
        });

        res.status(200).json(updatedWrestler);

    } catch (error) {

        console.error("Erreur updateWrestler :", error);
        
        if (error instanceof Error && error.message.includes("RecordNotFound")) {
            res.status(404).json({ error: "Ce wrestler n'existe pas" });
        } else {
            res.status(500).json({ error: "Erreur interne, veuillez réessayer plus tard" });
        }

    }

};


export const deleteWrestler = async (req: Request, res: Response): Promise<void> => {

    try {

        const { id } = req.params;
        const wrestlerId = Number(id);

        if (isNaN(wrestlerId)) {

            res.status(400).json({ error: "L'id fourni n'est pas valide" });
            return;

        }

        await prisma.wrestler.delete({ where: { id: wrestlerId } });

        res.status(204).end();

    } catch (error: any) {

        console.error("Erreur deleteWrestler :", error);
        
        if (error instanceof Error && error.message.includes("RecordNotFound")) {
            res.status(404).json({ error: "Ce wrestler n'existe pas" });
        } else if (error.code === "P2003") {
            res.status(400).json({ error: "Impossible de supprimer ce wrestler car il est référencé dans des matches" });
        } else {
            res.status(500).json({ error: "Erreur interne, veuillez réessayer plus tard" });
        }

    }

};