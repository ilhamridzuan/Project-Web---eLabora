import bcrypt from "bcrypt";
import jwt from "jsonwebtoken";
import { db } from "../../config/db.js";
import { AuthRepository } from "./auth.repository.js";

export const AuthService = {
  async registerPasien(payload) {
    const conn = await db.getConnection();
    try {
      await conn.beginTransaction();

      const rounds = Number(process.env.BCRYPT_ROUNDS || 10);
      const password_hash = await bcrypt.hash(payload.password, rounds);

      const akunId = await AuthRepository.insertAkun(conn, {
        username: payload.username,
        email: payload.email,
        password_hash
      });

      await AuthRepository.insertPasien(conn, {
        akun_id: akunId,
        nik: payload.nik,
        nama: payload.nama,
        tgl_lahir: payload.tgl_lahir || null,
        alamat: payload.alamat || null,
        no_telepon: payload.no_telepon || null
      });

      await conn.commit();

      // auto-login setelah register
      const token = jwt.sign(
        { akun_id: akunId, role: "PASIEN" },
        process.env.JWT_SECRET,
        { expiresIn: process.env.JWT_EXPIRES || "7d" }
      );

      return { id: akunId, role: "PASIEN", token };
    } catch (e) {
      await conn.rollback();
      throw e;
    } finally {
      conn.release();
    }
  },

  async login(payload) {
    const conn = await db.getConnection();
    try {
      const user = await AuthRepository.findAkunByUsername(conn, payload.username);
      if (!user) {
        // sengaja generic untuk keamanan
        return { ok: false, status: 401, message: "Invalid credentials" };
      }

      const ok = await bcrypt.compare(payload.password, user.password_hash);
      if (!ok) return { ok: false, status: 401, message: "Invalid credentials" };

      const token = jwt.sign(
        { akun_id: user.id, role: user.role },
        process.env.JWT_SECRET,
        { expiresIn: process.env.JWT_EXPIRES || "7d" }
      );

      return { ok: true, token, role: user.role };
    } finally {
      conn.release();
    }
  }
};
