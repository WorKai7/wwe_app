import { Request, Response } from 'express';

export function Hello(req: Request, res: Response) {
    res.status(200).json({ message: "Hello World !" });
}