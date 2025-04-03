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


export const createLocation = async (req: Request, res: Response): Promise<void> => {

    try {

        const { name } = req.body;

        if (!name) {

            res.status(400).json({ error: "Le champ 'name' est requis" });
            return;

        }

        const newLocation = await prisma.location.create({
            data: { name }
        });

        res.status(201).json(newLocation);

    } catch (error) {

        console.error("Erreur createLocation :", error);
        res.status(500).json({ error: "Erreur interne, veuillez réessayer plus tard" });

    }

};


export const updateLocation = async (req: Request, res: Response): Promise<void> => {

    try {

        const { id } = req.params;
        const { name } = req.body;
        const locationId = Number(id);

        if (isNaN(locationId)) {

            res.status(400).json({ error: "L'id fourni n'est pas valide" });
            return;

        }

        if (!name) {

            res.status(400).json({ error: "Le champ 'name' est requis" });
            return;

        }

        const updatedLocation = await prisma.location.update({
            where: { id: locationId },
            data: { name }
        });

        res.status(200).json(updatedLocation);

    } catch (error) {

        console.error("Erreur updateLocation :", error);
        
        if (error instanceof Error && error.message.includes("RecordNotFound")) {
            res.status(404).json({ error: "Cette location n'existe pas" });
        } else {
            res.status(500).json({ error: "Erreur interne, veuillez réessayer plus tard" });
        }

    }

};


export const deleteLocation = async (req: Request, res: Response): Promise<void> => {

    try {

        const { id } = req.params;
        const locationId = Number(id);

        if (isNaN(locationId)) {

            res.status(400).json({ error: "L'id fourni n'est pas valide" });
            return;

        }

        await prisma.location.delete({ where: { id: locationId } });

        res.status(204).end();

    } catch (error: any) {

        console.error("Erreur deleteLocation :", error);
        
        if (error instanceof Error && error.message.includes("RecordNotFound")) {
            res.status(404).json({ error: "Cette location n'existe pas" });
        } else if (error.code === "P2003") {
            res.status(400).json({ error: "Impossible de supprimer cette location car elle est référencée par d'autres enregistrements" });
        } else {
            res.status(500).json({ error: "Erreur interne, veuillez réessayer plus tard" });
        }

    }

};