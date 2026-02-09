---
description: ก่อนตอบคำถามทุกครั้ง ให้ค้นหาทักษะที่เกี่ยวข้องจากโฟลเดอร์ antigravity-awesome-skills/skills ก่อนเสมอ ห้ามตอบเองคิดเอง
---

# ขั้นตอนการตอบคำถามโดยอ้างอิง Skills

ทุกครั้งที่ได้รับคำถามหรือคำขอจากผู้ใช้ ให้ทำตามขั้นตอนนี้ **ก่อนตอบคำถาม**:

1. **วิเคราะห์คำถาม** — ระบุหัวข้อหรือเทคโนโลยีที่เกี่ยวข้องกับคำถาม (เช่น Laravel, React, database, API, testing, deployment ฯลฯ)

2. **ค้นหา skill ที่เกี่ยวข้อง** — ใช้ `find_by_name` หรือ `grep_search` ค้นหาในโฟลเดอร์:
   ```
   c:\Project\meims-system\antigravity-awesome-skills\skills
   ```
   โดยค้นหาชื่อโฟลเดอร์ skill ที่ตรงกับหัวข้อของคำถาม

3. **อ่านเนื้อหา skill** — เมื่อพบ skill ที่เกี่ยวข้อง ให้ใช้ `read_file` อ่านไฟล์ `.md` ภายในโฟลเดอร์ skill นั้น เพื่อทำความเข้าใจแนวทางปฏิบัติ (best practices) และคำแนะนำ

4. **ตอบคำถามตาม skill** — ตอบคำถามโดยอ้างอิงจากเนื้อหาใน skill ที่อ่านมา **ห้ามตอบเองคิดเอง** ถ้าไม่มี skill ที่เกี่ยวข้อง ให้แจ้งผู้ใช้ว่าไม่พบ skill ที่ตรงกับคำถาม

## ตัวอย่าง

- คำถามเกี่ยวกับ Laravel → ค้นหา skill เช่น `php-pro`, `api-patterns`, `database-design`
- คำถามเกี่ยวกับ React → ค้นหา skill เช่น `react-best-practices`, `react-patterns`
- คำถามเกี่ยวกับ Database → ค้นหา skill เช่น `database-design`, `database-migrations`, `sql-optimization-patterns`
- คำถามเกี่ยวกับ Testing → ค้นหา skill เช่น `testing-patterns`, `tdd-workflows`

## สำคัญ

- **ห้ามข้ามขั้นตอนนี้** — ต้องค้นหาและอ่าน skill ก่อนตอบทุกครั้ง
- **ห้ามตอบจากความรู้ของตัวเอง** — ต้องอ้างอิงจาก skill เท่านั้น
- ถ้าพบหลาย skill ที่เกี่ยวข้อง ให้อ่านทุก skill แล้วรวมคำตอบ
