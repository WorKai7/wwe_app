import { NextFunction, Response, Request } from 'express';
import jwt from 'jsonwebtoken';
import process from 'process';

export const verifyJWT = (req: Request, res: Response, next: NextFunction) => {
    const authHeader = req.headers.authorization;
    const secret = process.env.JWT_SECRET || null;
    if (authHeader && secret !== null) {
        const token = authHeader.split(' ')[1];
        const decoded = jwt.verify(token, secret as jwt.Secret) as { userId: string };
        const userId = decoded.userId;
        req.query.userId = userId;
        next();
    } else {
        res.status(401).json({ error: "Accès refusé" });
    }

}