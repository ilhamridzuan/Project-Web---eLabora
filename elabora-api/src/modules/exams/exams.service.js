import path from "path";
import { db } from "../../config/db.js";
import { ExamsRepository } from "./exams.repository.js";

export const ExamsService = {
    async listByPatient(pasienId) {
        const conn = await db.getConnection();
        try {
            return await ExamsRepository.listByPatient(conn, { pasien_id: pasienId });
        } finally {
            conn.release();
        }
    },



    async detail(pemeriksaanId) {
        const conn = await db.getConnection();
        try {
            const item = await ExamsRepository.getDetail(conn, pemeriksaanId);
            if (!item) {
                const err = new Error("Pemeriksaan not found");
                err.statusCode = 404;
                throw err;
            }
            const files = await ExamsRepository.listFiles(conn, pemeriksaanId);
            return { ...item, files };
        } finally {
            conn.release();
        }
    },

    async create({ payload, akunId }) {
        const conn = await db.getConnection();
        try {
            const petugasLab = await ExamsRepository.findPetugasLabIdByAkunId(conn, akunId);
            if (!petugasLab) {
                throw new Error("Data petugas_lab tidak ditemukan untuk akun ini");
            }
            const petugasLabId = petugasLab.id;
            const id = await ExamsRepository.create(conn, { ...payload, petugas_lab_id: petugasLabId });
            return await ExamsRepository.getDetail(conn, id);
        } finally {
            conn.release();
        }
    },

    async update(pemeriksaanId, patch) {
        const conn = await db.getConnection();
        try {
            await ExamsRepository.update(conn, pemeriksaanId, patch);
            return await ExamsRepository.getDetail(conn, pemeriksaanId);
        } finally {
            conn.release();
        }
    },

    async attachFile({ pemeriksaanId, file }) {
        const allowed = ["application/pdf", "image/jpeg", "image/png"];
        if (!allowed.includes(file.mimetype)) {
            const err = new Error("File type not allowed");
            err.statusCode = 422;
            throw err;
        }

        // store relative path for DB
        const relative = path.posix.join("/uploads", path.basename(file.path));

        const conn = await db.getConnection();
        try {
            await ExamsRepository.insertFile(conn, {
                pemeriksaan_id: pemeriksaanId,
                file_path: relative,
                mime_type: file.mimetype,
            });
            return await ExamsRepository.listFiles(conn, pemeriksaanId);
        } finally {
            conn.release();
        }
    },
};
