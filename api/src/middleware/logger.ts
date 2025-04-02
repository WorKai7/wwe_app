import { Request, Response, NextFunction } from 'express';

export function logger(req: Request, res: Response, next: NextFunction) {
    const now = new Date();
    console.log(`LOG : ${now.toLocaleString()} ${req.method} ${req.url}`);
    next();
}