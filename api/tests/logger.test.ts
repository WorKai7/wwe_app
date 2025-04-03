import { Request, Response, NextFunction } from "express";
import { logger } from "../src/middleware/logger";

describe("Middleware logger", () => {
    let req: Partial<Request>;
    let res: Partial<Response>;
    let next: NextFunction;
    let consoleSpy: jest.SpyInstance;

    beforeEach(() => {
        req = {
            method: "GET",
            url: "/test"
        };
        res = {};
        next = jest.fn();
        consoleSpy = jest.spyOn(console, "log").mockImplementation(() => {});
    });

    afterEach(() => {
        consoleSpy.mockRestore();
    });

    it("doit appeler console.log et le next()", () => {
        logger(req as Request, res as Response, next);
        expect(consoleSpy).toHaveBeenCalledTimes(1);
        expect(consoleSpy.mock.calls[0][0]).toMatch(/GET/);
        expect(consoleSpy.mock.calls[0][0]).toMatch(/\/test/);
        expect(next).toHaveBeenCalled();
    });
});