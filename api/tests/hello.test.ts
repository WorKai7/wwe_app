import request from "supertest";
import { app } from "../index";

describe("GET /hello", () => {
    it("should return a 200 status and a greeting message", async () => {
        
        const response: any = await request(app).get("/public/hello").send();

        expect(response.status).toBe(200);
        expect(response.body).toEqual({ message: "Hello World !" });
    });
});