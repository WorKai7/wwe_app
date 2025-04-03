import request from "supertest";
import { app } from "../src/index";
import { prismaMock } from "./jest.setup";

const mockedPromotion = {
    id: 1,
    name: "WWE"
};

describe("GET /promotions/:id", () => {
    it("should return a 200 status and the promotion having the given id", async () => {
        prismaMock.promotion.findUnique.mockResolvedValue(mockedPromotion);
        const response: any = await request(app).get("/promotions/1").send();
        expect(response.status).toBe(200);
        expect(response.body).toEqual(mockedPromotion);
    });
    it("should return 400 for an invalid id", async () => {
        const response: any = await request(app).get("/promotions/abc").send();
        expect(response.status).toBe(400);
        expect(response.body).toEqual({ error: "L'id fourni n'est pas valide" });
    });
    it("should return 404 if the promotion is not found", async () => {
        prismaMock.promotion.findUnique.mockResolvedValue(null);
        const response: any = await request(app).get("/promotions/9999").send();
        expect(response.status).toBe(404);
        expect(response.body).toEqual({ error: "Cette promotion n'existe pas" });
    });
});

describe("GET /promotions", () => {
    it("should return a list of promotions", async () => {
        const mockedPromotions = [
            mockedPromotion,
            { id: 2, name: "AEW" }
        ];
        prismaMock.promotion.findMany.mockResolvedValue(mockedPromotions);
        const response: any = await request(app).get("/promotions").send();
        expect(response.status).toBe(200);
        expect(response.body).toEqual(mockedPromotions);
    });
});

describe("POST /promotions", () => {
    it("should create a new promotion", async () => {
        const newPromotion = { id: 3, name: "Impact Wrestling" };
        prismaMock.promotion.create.mockResolvedValue(newPromotion);
        const response: any = await request(app)
            .post("/promotions")
            .send({ name: newPromotion.name });
        expect(response.status).toBe(201);
        expect(response.body).toEqual(newPromotion);
    });
    it("should return 400 if the name is missing", async () => {
        const response: any = await request(app).post("/promotions").send({});
        expect(response.status).toBe(400);
        expect(response.body).toEqual({ error: "Le champ 'name' est requis" });
    });
});

describe("PUT /promotions/:id", () => {
    it("should update an existing promotion", async () => {
        const updatedPromotion = { ...mockedPromotion, name: "WWE Updated" };
        prismaMock.promotion.update.mockResolvedValue(updatedPromotion);
        const response: any = await request(app)
            .put("/promotions/1")
            .send({ name: "WWE Updated" });
        expect(response.status).toBe(200);
        expect(response.body).toEqual(updatedPromotion);
    });
    it("should return 400 for an invalid id", async () => {
        const response: any = await request(app)
            .put("/promotions/abc")
            .send({ name: "Test" });
        expect(response.status).toBe(400);
        expect(response.body).toEqual({ error: "L'id fourni n'est pas valide" });
    });
});

describe("DELETE /promotions/:id", () => {
    it("should delete an existing promotion", async () => {
        prismaMock.promotion.delete.mockResolvedValue(mockedPromotion);
        const response: any = await request(app).delete("/promotions/1").send();
        expect(response.status).toBe(204);
    });
    it("should return 400 for an invalid id", async () => {
        const response: any = await request(app).delete("/promotions/abc").send();
        expect(response.status).toBe(400);
        expect(response.body).toEqual({ error: "L'id fourni n'est pas valide" });
    });
});