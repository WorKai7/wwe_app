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