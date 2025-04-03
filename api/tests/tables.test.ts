import request from "supertest";
import { app } from "../src/index";
import { prismaMock } from "./jest.setup";

const mockedTable = {
    id: 1,
    html: "<p>Table HTML</p>",
    url: "http://example.com/table/1"
};

describe("GET /tables/:id", () => {
    it("should return a 200 status and the table having the given id", async () => {
        prismaMock.table.findUnique.mockResolvedValue(mockedTable);
        const response: any = await request(app).get("/tables/1").send();
        expect(response.status).toBe(200);
        expect(response.body).toEqual(mockedTable);
    });

    it("should return 400 for an invalid id", async () => {
        const response: any = await request(app).get("/tables/abc").send();
        expect(response.status).toBe(400);
        expect(response.body).toEqual({ error: "L'id fourni n'est pas valide" });
    });

    it("should return 404 if the table is not found", async () => {
        prismaMock.table.findUnique.mockResolvedValue(null);
        const response: any = await request(app).get("/tables/9999").send();
        expect(response.status).toBe(404);
        expect(response.body).toEqual({ error: "Cette table n'existe pas" });
    });
});

describe("GET /tables", () => {
    it("should return a list of tables", async () => {
        const mockedTables = [
            mockedTable,
            { id: 2, html: "<p>Another HTML</p>", url: "http://example.com/table/2" }
        ];
        prismaMock.table.findMany.mockResolvedValue(mockedTables);
        const response: any = await request(app).get("/tables").send();
        expect(response.status).toBe(200);
        expect(response.body).toEqual(mockedTables);
    });
});

describe("POST /tables", () => {
    it("should create a new table", async () => {
        const newTable = { id: 3, html: "<p>New Table HTML</p>", url: "http://example.com/table/3" };
        prismaMock.table.create.mockResolvedValue(newTable);
        const response: any = await request(app)
            .post("/tables")
            .send({ html: newTable.html, url: newTable.url });
        expect(response.status).toBe(201);
        expect(response.body).toEqual(newTable);
    });
});

describe("PUT /tables/:id", () => {
    it("should update an existing table", async () => {
        const updatedTable = { id: 1, html: "<p>Updated HTML</p>", url: "http://example.com/table/updated" };
        prismaMock.table.update.mockResolvedValue(updatedTable);
        const response: any = await request(app)
            .put("/tables/1")
            .send({ html: "Updated HTML", url: "http://example.com/table/updated" });
        expect(response.status).toBe(200);
        expect(response.body).toEqual(updatedTable);
    });

    it("should return 400 for an invalid id", async () => {
        const response: any = await request(app)
            .put("/tables/abc")
            .send({ html: "Updated HTML", url: "http://example.com/table/updated" });
        expect(response.status).toBe(400);
        expect(response.body).toEqual({ error: "L'id fourni n'est pas valide" });
    });
});

describe("DELETE /tables/:id", () => {
    it("should delete an existing table", async () => {
        prismaMock.table.delete.mockResolvedValue(mockedTable);
        const response: any = await request(app).delete("/tables/1").send();
        expect(response.status).toBe(204);
    });

    it("should return 400 for an invalid id", async () => {
        const response: any = await request(app).delete("/tables/abc").send();
        expect(response.status).toBe(400);
        expect(response.body).toEqual({ error: "L'id fourni n'est pas valide" });
    });
});