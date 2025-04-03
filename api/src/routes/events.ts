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


export const createEvent = async (req: Request, res: Response): Promise<void> => {

    try {

        const { name } = req.body;

        if (!name) {

            res.status(400).json({ error: "Le champ 'name' est requis" });
            return;

        }

        const newEvent = await prisma.event.create({
            data: { name }
        });

        res.status(201).json(newEvent);

    } catch (error) {

        console.error("Erreur createEvent :", error);
        res.status(500).json({ error: "Erreur interne, veuillez réessayer plus tard" });

    }

};


export const updateEvent = async (req: Request, res: Response): Promise<void> => {

    try {

        const { id } = req.params;
        const { name } = req.body;
        const eventId = Number(id);

        if (isNaN(eventId)) {

            res.status(400).json({ error: "L'id fourni n'est pas valide" });
            return;

        }

        if (!name) {

            res.status(400).json({ error: "Le champ 'name' est requis" });
            return;

        }

        const updatedEvent = await prisma.event.update({
            where: { id: eventId },
            data: { name }
        });

        res.status(200).json(updatedEvent);

    } catch (error) {

        console.error("Erreur updateEvent :", error);
        
        if (error instanceof Error && error.message.includes("RecordNotFound")) {
            res.status(404).json({ error: "Cet event n'existe pas" });
        } else {
            res.status(500).json({ error: "Erreur interne, veuillez réessayer plus tard" });
        }

    }

};


export const deleteEvent = async (req: Request, res: Response): Promise<void> => {

    try {

        const { id } = req.params;
        const eventId = Number(id);

        if (isNaN(eventId)) {

            res.status(400).json({ error: "L'id fourni n'est pas valide" });
            return;

        }

        await prisma.event.delete({ where: { id: eventId } });

        res.status(204).end();

    } catch (error) {

        console.error("Erreur deleteEvent :", error);
        
        if (error instanceof Error && error.message.includes("RecordNotFound")) {
            res.status(404).json({ error: "Cet event n'existe pas" });
        } else {
            res.status(500).json({ error: "Erreur interne, veuillez réessayer plus tard" });
        }

    }

};