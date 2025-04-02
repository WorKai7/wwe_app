import { Request, Response } from "express";
import prisma from "../client";


export const getAllLocations = async (req: Request, res: Response): Promise<void> => {

    try {

        const locations = await prisma.location.findMany();
        res.status(200).json(locations);

    } catch (error) {

        console.error("Erreur getAllLocations :", error);
        res.status(500).json({ error: "Erreur interne, veuillez réessayer plus tard" });

    }

};


export const getLocationById = async (req: Request, res: Response): Promise<void> => {

    try {

        const { id } = req.params;
        const locationId = Number(id);

        if (isNaN(locationId)) {

            res.status(400).json({ error: "L'id fourni n'est pas valide" });
            return;

        }

        const location = await prisma.location.findUnique({ where: { id: locationId } });

        if (!location) {

            res.status(404).json({ error: "Cette location n'existe pas" });
            return;

        }

        res.status(200).json(location);

    } catch (error) {

        console.error("Erreur getLocationById :", error);
        res.status(500).json({ error: "Erreur interne, veuillez réessayer plus tard" });

    }

};