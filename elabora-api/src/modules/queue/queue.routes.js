import express from "express";
import { requireAuth, requireRole } from "../../middleware/auth.middleware.js";
import { listToday, callQueue, nextQueue, cancelQueue } from "./queue.controller.js";

const router = express.Router();

// Petugas only (Manajemen Antrian)
router.get("/today", requireAuth, requireRole("PETUGAS"), listToday);
router.post("/:id/call", requireAuth, requireRole("PETUGAS"), callQueue);
router.post("/:id/next", requireAuth, requireRole("PETUGAS"), nextQueue);
router.post("/:id/cancel", requireAuth, requireRole("PETUGAS"), cancelQueue);

export default router;
