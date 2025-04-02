import { Request, Response, RequestHandler } from "express";
import prisma from "../client";
import bcrypt from "bcrypt";
import jwt from "jsonwebtoken";


export const login = async (req: Request, res: Response): Promise<void> => {

    try {

        const { username, password } = req.body;
        if (!username || !password) {
            res.status(400).json({ error: "Entrez un email et un mot de passe" });
            return;
        }

        const user = await prisma.user.findUnique({ where: { username } })
        if (!user) {
            res.status(401).json({ error: "Entrez un nom d'utilisateur valide" });
            return;
        }
        
        const result = await bcrypt.compare(password, user.password);
        if (!result) {
            res.status(401).json({ error: "Mot de passe incorrect" });
            return;
        }

        const jwtSecret = process.env.JWT_SECRET;
        if (!jwtSecret) {
            res.status(500).json({ error: "Erreur interne, veuillez réessayer plus tard" });
            return;
        }

        const token = jwt.sign({ id: user.id }, jwtSecret, { expiresIn: "2h" });

        res.status(200).json({ token });
        return;

    } catch (error) {

        console.error("Erreur :", error);
        res.status(500).json({ error: "Erreur interne, veuillez réessayer plus tard" });
        return;

    }
    
}


export const register = async (req: Request, res: Response): Promise<void> => {

    try {
        const { username, password } = req.body;
        if (!username || !password) {
            res.status(400).json({ error: "Entrez un email et un mot de passe" });
            return;
        }

        const hashedPassword = await bcrypt.hash(password, 10);
        const user = await prisma.user.create({
            data: {
                username,
                password: hashedPassword,
            },
        });

        res.status(201).json(user);
        return;

    } catch (error) {

        console.error("Erreur :", error);
        res.status(500).json({ error: "Erreur interne, veuillez réessayer plus tard" });
        return;

    }
    
}