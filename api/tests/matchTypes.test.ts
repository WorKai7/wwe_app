import request from "supertest";
import { app } from "../index";
import { prismaMock } from "./jest.setup";

const mockedMatchType = {
    id: 1,
    name: "Singles"
};

describe("GET /matchTypes/:id", () => {
    it("should return a 200 status and the match type having the given id", async () => {
        prismaMock.matchType.findUnique.mockResolvedValue(mockedMatchType);
        const response: any = await request(app).get("/matchTypes/1").send();
        expect(response.status).toBe(200);
        expect(response.body).toEqual(mockedMatchType);
    });

    it("should return 400 for an invalid id", async () => {
        const response: any = await request(app).get("/matchTypes/abc").send();
        expect(response.status).toBe(400);
        expect(response.body).toEqual({ error: "L'id fourni n'est pas valide" });
    });

    it("should return 404 if the match type is not found", async () => {
        prismaMock.matchType.findUnique.mockResolvedValue(null);
        const response: any = await request(app).get("/matchTypes/9999").send();
        expect(response.status).toBe(404);
        expect(response.body).toEqual({ error: "Ce match type n'existe pas" });
    });
});

describe("GET /matchTypes", () => {
    it("should return a list of match types", async () => {
        const mockedMatchTypes = [
            mockedMatchType,
            { id: 2, name: "Tag Team" }
        ];
        prismaMock.matchType.findMany.mockResolvedValue(mockedMatchTypes);
        const response: any = await request(app).get("/matchTypes").send();
        expect(response.status).toBe(200);
        expect(response.body).toEqual(mockedMatchTypes);
    });
});

describe("POST /matchTypes", () => {
    it("should create a new match type", async () => {
        const newMatchType = { id: 3, name: "Triple Threat" };
        prismaMock.matchType.create.mockResolvedValue(newMatchType);
        const response: any = await request(app)
            .post("/matchTypes")
            .send({ name: newMatchType.name });
        expect(response.status).toBe(201);
        expect(response.body).toEqual(newMatchType);
    });

    it("should return 400 if the name is missing", async () => {
        const response: any = await request(app).post("/matchTypes").send({});
        expect(response.status).toBe(400);
        expect(response.body).toEqual({ error: "Le champ 'name' est requis" });
    });
});

describe("PUT /matchTypes/:id", () => {
    it("should update an existing match type", async () => {
        const updatedMatchType = { ...mockedMatchType, name: "Singles Updated" };
        prismaMock.matchType.update.mockResolvedValue(updatedMatchType);
        const response: any = await request(app)
            .put("/matchTypes/1")
            .send({ name: "Singles Updated" });
        expect(response.status).toBe(200);
        expect(response.body).toEqual(updatedMatchType);
    });

    it("should return 400 for an invalid id", async () => {
        const response: any = await request(app)
            .put("/matchTypes/abc")
            .send({ name: "Test" });
        expect(response.status).toBe(400);
        expect(response.body).toEqual({ error: "L'id fourni n'est pas valide" });
    });
});

describe("DELETE /matchTypes/:id", () => {
    it("should delete an existing match type", async () => {
        prismaMock.matchType.delete.mockResolvedValue(mockedMatchType);
        const response: any = await request(app).delete("/matchTypes/1").send();
        expect(response.status).toBe(204);
    });

    it("should return 400 for an invalid id", async () => {
        const response: any = await request(app).delete("/matchTypes/abc").send();
        expect(response.status).toBe(400);
        expect(response.body).toEqual({ error: "L'id fourni n'est pas valide" });
    });
});