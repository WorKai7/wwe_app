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


export const createMatchType = async (req: Request, res: Response): Promise<void> => {

    try {

        const { name } = req.body;

        if (!name) {

            res.status(400).json({ error: "Le champ 'name' est requis" });
            return;

        }

        const newMatchType = await prisma.matchType.create({
            data: { name }
        });

        res.status(201).json(newMatchType);

    } catch (error) {

        console.error("Erreur createMatchType :", error);
        res.status(500).json({ error: "Erreur interne, veuillez réessayer plus tard" });

    }

};


export const updateMatchType = async (req: Request, res: Response): Promise<void> => {

    try {

        const { id } = req.params;
        const { name } = req.body;
        const matchTypeId = Number(id);

        if (isNaN(matchTypeId)) {

            res.status(400).json({ error: "L'id fourni n'est pas valide" });
            return;

        }

        if (!name) {

            res.status(400).json({ error: "Le champ 'name' est requis" });
            return;

        }

        const updatedMatchType = await prisma.matchType.update({
            where: { id: matchTypeId },
            data: { name }
        });

        res.status(200).json(updatedMatchType);

    } catch (error) {

        console.error("Erreur updateMatchType :", error);
        
        if (error instanceof Error && error.message.includes("RecordNotFound")) {
            res.status(404).json({ error: "Ce match type n'existe pas" });
        } else {
            res.status(500).json({ error: "Erreur interne, veuillez réessayer plus tard" });
        }

    }

};


export const deleteMatchType = async (req: Request, res: Response): Promise<void> => {

    try {

        const { id } = req.params;
        const matchTypeId = Number(id);

        if (isNaN(matchTypeId)) {

            res.status(400).json({ error: "L'id fourni n'est pas valide" });
            return;

        }

        await prisma.matchType.delete({ where: { id: matchTypeId } });

        res.status(204).end();

    } catch (error: any) {

        console.error("Erreur deleteMatchType :", error);
        
        if (error instanceof Error && error.message.includes("RecordNotFound")) {
            res.status(404).json({ error: "Ce match type n'existe pas" });
        } else if (error.code === "P2003") {
            res.status(400).json({ error: "Impossible de supprimer ce type de match car il est référencé par d'autres enregistrements" });
        } else {
            res.status(500).json({ error: "Erreur interne, veuillez réessayer plus tard" });
        }

    }

};