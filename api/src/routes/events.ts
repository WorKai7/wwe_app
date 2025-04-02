import { Request, Response } from "express";
import prisma from "../client";


export const getAllEvents = async (req: Request, res: Response): Promise<void> => {

    try {

        const events = await prisma.event.findMany();
        res.status(200).json(events);

    } catch (error) {

        console.error("Erreur getAllEvents :", error);
        res.status(500).json({ error: "Erreur interne, veuillez réessayer plus tard" });

    }

};


export const getEventById = async (req: Request, res: Response): Promise<void> => {

    try {

        const { id } = req.params;
        const eventId = Number(id);

        if (isNaN(eventId)) {

            res.status(400).json({ error: "L'id fourni n'est pas valide" });
            return;

        }

        const event = await prisma.event.findUnique({ where: { id: eventId } });

        if (!event) {

            res.status(404).json({ error: "Cet event n'existe pas" });
            return;

        }

        res.status(200).json(event);

    } catch (error) {

        console.error("Erreur getEventById :", error);
        res.status(500).json({ error: "Erreur interne, veuillez réessayer plus tard" });

    }

};