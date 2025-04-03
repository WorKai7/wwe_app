process.env.API_PORT = "2022";

import { PrismaClient } from '@prisma/client';
import { mockDeep, mockReset, DeepMockProxy } from 'jest-mock-extended';
import { closeServer } from '../src/index';
import prisma from '../src/client';

// Mock de PrismaClient
jest.mock('../src/client', () => ({
  __esModule: true,
  default: mockDeep<PrismaClient>(),
}));

// Mock de jsonwebtoken
jest.mock('jsonwebtoken', () => ({
  ...jest.requireActual('jsonwebtoken'),
  verify: jest.fn((token, _secret) => {
    if (token === 'mockedToken') {
      return { userId: 'mockedUserId' };
    }
    throw new Error('Invalid token');
  }),
  sign: jest.fn(() => 'mockedToken'),
}));

// Mock de bcrypt
jest.mock('bcrypt', () => ({
  compare: jest.fn((password, hashed) => {
    // On retourne true si les valeurs correspondent aux attentes de tests
    if (password === "secretpassword" && hashed === "hashedPassword") {
      return Promise.resolve(true);
    }
    return Promise.resolve(false);
  }),
  hash: jest.fn((password) => Promise.resolve("hashed_" + password))
}));

jest.mock('../src/middleware/auth', () => ({
  verifyJWT: (req: any, _res: any, next: any) => {
    req.query.userId = 'mockedUserId';
    next();
  }
}));

export const prismaMock = prisma as unknown as DeepMockProxy<PrismaClient>;

beforeEach(() => {
  mockReset(prismaMock);
  jest.clearAllMocks();
});

afterAll(() => {
    closeServer();
});