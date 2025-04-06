import request from "supertest";
import { app } from "../index";
import { prismaMock } from "./jest.setup";


describe("GET /belts/:id", () => {
    const mockedBelt = { id: 9, name: "WWF Championship" };
    it("should return a 200 status and the belt having the given id", async () => {
        prismaMock.belt.findUnique.mockResolvedValue(mockedBelt);
        const response: any = await request(app).get("/belts/9").send();

        expect(response.status).toBe(200);
        expect(response.body).toEqual(mockedBelt);
    });
});

describe("GET /belts", () => {
    it("should return a list of belts", async () => {
        const mockedBelts = [
            { id: 9, name: "WWWF World Heavyweight Title" },
            { id: 10, name: "WWWF Cruiserweight Title" },
        ];
        prismaMock.belt.findMany.mockResolvedValue(mockedBelts);
        const response: any = await request(app).get("/belts").send();

        expect(response.status).toBe(200);
        expect(response.body).toEqual(mockedBelts);
    });
});

describe("POST /belts", () => {
    it("should create a new belt", async () => {
        const newBelt = { id: 11, name: "New Belt" };
        prismaMock.belt.create.mockResolvedValue(newBelt);
        const response: any = await request(app)
            .post("/belts")
            .send({ name: "New Belt" });

        expect(response.status).toBe(201);
        expect(response.body).toEqual(newBelt);
    });

    it("should return 400 if the name is missing", async () => {
        const response: any = await request(app)
            .post("/belts")
            .send({});

        expect(response.status).toBe(400);
        expect(response.body).toEqual({ error: "Le champ 'name' est requis" });
    });
});

describe("PUT /belts/:id", () => {
    it("should update an existing belt", async () => {
        const updatedBelt = { id: 9, name: "Updated Belt Name" };
        prismaMock.belt.update.mockResolvedValue(updatedBelt);
        const response: any = await request(app)
            .put("/belts/9")
            .send({ name: "Updated Belt Name" });

        expect(response.status).toBe(200);
        expect(response.body).toEqual(updatedBelt);
    });

    it("should return 400 for an invalid id", async () => {
        const response: any = await request(app)
            .put("/belts/abc")
            .send({ name: "Updated Belt Name" });

        expect(response.status).toBe(400);
        expect(response.body).toEqual({ error: "L'id fourni n'est pas valide" });
    });

    it("should return 400 when name is missing", async () => {
        const response: any = await request(app)
            .put("/belts/9")
            .send({});

        expect(response.status).toBe(400);
        expect(response.body).toEqual({ error: "Le champ 'name' est requis" });
    });
});

describe("DELETE /belts/:id", () => {
    it("should delete an existing belt", async () => {
        const deletedBelt = { id: 9, name: null };
        prismaMock.belt.delete.mockResolvedValue(deletedBelt);
        const response: any = await request(app)
            .delete("/belts/9")
            .send();

        expect(response.status).toBe(204);
    });

    it("should return 400 for an invalid id", async () => {
        const response: any = await request(app)
            .delete("/belts/abc")
            .send();

        expect(response.status).toBe(400);
        expect(response.body).toEqual({ error: "L'id fourni n'est pas valide" });
    });
});