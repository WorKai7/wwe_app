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


export const createMatch = async (req: Request, res: Response): Promise<void> => {

    try {

        const { 
            card_id,
            winner_id,
            win_type,
            loser_id,
            match_type_id,
            duration,
            title_id,
            title_change 
        } = req.body;

        const newMatch = await prisma.match.create({
            data: {
                card_id,
                winner_id,
                win_type,
                loser_id,
                match_type_id,
                duration,
                title_id,
                title_change: title_change ? parseInt(title_change) : null
            }
        });

        res.status(201).json(newMatch);

    } catch (error) {

        console.error("Erreur createMatch :", error);
        res.status(500).json({ error: "Erreur interne, veuillez réessayer plus tard" });

    }

};


export const updateMatch = async (req: Request, res: Response): Promise<void> => {

    try {

        const { id } = req.params;
        const { 
            card_id,
            winner_id,
            win_type,
            loser_id,
            match_type_id,
            duration,
            title_id,
            title_change 
        } = req.body;
        
        const matchId = Number(id);

        if (isNaN(matchId)) {

            res.status(400).json({ error: "L'id fourni n'est pas valide" });
            return;

        }

        const updatedMatch = await prisma.match.update({
            where: { id: matchId },
            data: {
                card_id,
                winner_id,
                win_type,
                loser_id,
                match_type_id,
                duration,
                title_id,
                title_change: title_change ? parseInt(title_change) : null
            }
        });

        res.status(200).json(updatedMatch);

    } catch (error) {

        console.error("Erreur updateMatch :", error);
        
        if (error instanceof Error && error.message.includes("RecordNotFound")) {
            res.status(404).json({ error: "Ce match n'existe pas" });
        } else {
            res.status(500).json({ error: "Erreur interne, veuillez réessayer plus tard" });
        }

    }

};


export const deleteMatch = async (req: Request, res: Response): Promise<void> => {

    try {

        const { id } = req.params;
        const matchId = Number(id);

        if (isNaN(matchId)) {

            res.status(400).json({ error: "L'id fourni n'est pas valide" });
            return;

        }

        await prisma.match.delete({ where: { id: matchId } });

        res.status(204).end();

    } catch (error) {

        console.error("Erreur deleteMatch :", error);
        
        if (error instanceof Error && error.message.includes("RecordNotFound")) {
            res.status(404).json({ error: "Ce match n'existe pas" });
        } else {
            res.status(500).json({ error: "Erreur interne, veuillez réessayer plus tard" });
        }

    }

};