import { Request, Response } from "express";
import prisma from "../client";


export const getAllTables = async (req: Request, res: Response): Promise<void> => {

    try {

        const tables = await prisma.table.findMany();
        res.status(200).json(tables);

    } catch (error) {

        console.error("Erreur getAllTables :", error);
        res.status(500).json({ error: "Erreur interne, veuillez réessayer plus tard" });

    }

};


export const getTableById = async (req: Request, res: Response): Promise<void> => {

    try {

        const { id } = req.params;
        const tableId = Number(id);

        if (isNaN(tableId)) {

            res.status(400).json({ error: "L'id fourni n'est pas valide" });
            return;

        }

        const table = await prisma.table.findUnique({ where: { id: tableId } });

        if (!table) {

            res.status(404).json({ error: "Cette table n'existe pas" });
            return;

        }

        res.status(200).json(table);

    } catch (error) {

        console.error("Erreur getTableById :", error);
        res.status(500).json({ error: "Erreur interne, veuillez réessayer plus tard" });

    }

};


export const createTable = async (req: Request, res: Response): Promise<void> => {

    try {

        const { html, url } = req.body;

        const newTable = await prisma.table.create({
            data: {
                html,
                url
            }
        });

        res.status(201).json(newTable);

    } catch (error) {

        console.error("Erreur createTable :", error);
        res.status(500).json({ error: "Erreur interne, veuillez réessayer plus tard" });

    }

};


export const updateTable = async (req: Request, res: Response): Promise<void> => {

    try {

        const { id } = req.params;
        const { html, url } = req.body;
        const tableId = Number(id);

        if (isNaN(tableId)) {

            res.status(400).json({ error: "L'id fourni n'est pas valide" });
            return;

        }

        const updatedTable = await prisma.table.update({
            where: { id: tableId },
            data: {
                html,
                url
            }
        });

        res.status(200).json(updatedTable);

    } catch (error) {

        console.error("Erreur updateTable :", error);
        
        if (error instanceof Error && error.message.includes("RecordNotFound")) {
            res.status(404).json({ error: "Cette table n'existe pas" });
        } else {
            res.status(500).json({ error: "Erreur interne, veuillez réessayer plus tard" });
        }

    }

};


export const deleteTable = async (req: Request, res: Response): Promise<void> => {

    try {

        const { id } = req.params;
        const tableId = Number(id);

        if (isNaN(tableId)) {

            res.status(400).json({ error: "L'id fourni n'est pas valide" });
            return;

        }

        await prisma.table.delete({ where: { id: tableId } });

        res.status(204).end();

    } catch (error: any) {

        console.error("Erreur deleteTable :", error);
        
        if (error instanceof Error && error.message.includes("RecordNotFound")) {
            res.status(404).json({ error: "Cette table n'existe pas" });
        } else if (error.code === "P2003") {
            res.status(400).json({ error: "Impossible de supprimer cette table car elle est référencée par d'autres enregistrements" });
        } else {
            res.status(500).json({ error: "Erreur interne, veuillez réessayer plus tard" });
        }

    }

};