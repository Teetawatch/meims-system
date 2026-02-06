---
description: Always check skills folder before answering any question
---

# Skill-First Response Workflow

ก่อนตอบคำถามใดๆ ให้ปฏิบัติตามขั้นตอนดังนี้:

## ขั้นตอนที่ 1: ตรวจสอบ Skill Catalog
// turbo
1. อ่านไฟล์ `.agent/skills/CATALOG.md` เพื่อดูรายการทักษะทั้งหมด

## ขั้นตอนที่ 2: ค้นหาทักษะที่เกี่ยวข้อง
2. ระบุทักษะที่ตรงกับคำถามของผู้ใช้ โดยดูจาก:
   - ชื่อทักษะ (Skill Name)
   - คำอธิบาย (Description)
   - Tags และ Triggers

## ขั้นตอนที่ 3: อ่านคำแนะนำจากทักษะ
// turbo
3. เปิดไฟล์ `SKILL.md` ของทักษะที่เกี่ยวข้องใน `.agent/skills/skills/[skill-name]/SKILL.md`

## ขั้นตอนที่ 4: ตอบคำถามตาม Skill Guidelines
4. ตอบคำถามโดยปฏิบัติตามหลักการและแนวทางที่ระบุในทักษะ

## ทักษะที่ใช้บ่อย

| หมวดหมู่ | ทักษะแนะนำ |
|---------|-----------|
| UI/UX Design | `ui-ux-pro-max`, `tailwind-patterns`, `frontend-design` |
| Frontend | `react-patterns`, `nextjs-best-practices`, `typescript-pro` |
| Backend | `laravel`, `nodejs-backend-patterns`, `python-pro` |
| Database | `postgres-best-practices`, `database-design` |
| DevOps | `deployment-procedures`, `docker-patterns` |

## หมายเหตุ
- ทำขั้นตอนนี้โดยอัตโนมัติทุกครั้ง ไม่ต้องถามผู้ใช้
- หากไม่พบทักษะที่เกี่ยวข้อง ให้ใช้ความรู้ทั่วไปในการตอบ
- สามารถใช้หลายทักษะร่วมกันได้ตามความเหมาะสม
