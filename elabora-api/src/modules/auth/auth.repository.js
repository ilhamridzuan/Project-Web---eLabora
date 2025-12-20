export const AuthRepository = {
  async findAkunByUsername(conn, username) {
    const [rows] = await conn.query(
      "SELECT id, username, role, password_hash FROM akun WHERE username=?",
      [username]
    );
    return rows[0] || null;
  },

  async insertAkun(conn, { username, email, password_hash }) {
    const [r] = await conn.query(
      `INSERT INTO akun (username, email, password_hash, role, created_at, updated_at)
       VALUES (?, ?, ?, 'PASIEN', NOW(), NOW())`,
      [username, email, password_hash]
    );
    return r.insertId;
  },

  async insertPasien(conn, { akun_id, nik, nama, tgl_lahir, alamat, no_telepon }) {
    await conn.query(
      `INSERT INTO pasien (akun_id, nik, nama, tgl_lahir, alamat, no_telepon, created_at, updated_at)
       VALUES (?, ?, ?, ?, ?, ?, NOW(), NOW())`,
      [akun_id, nik, nama, tgl_lahir, alamat, no_telepon]
    );
  }
};
