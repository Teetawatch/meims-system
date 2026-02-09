---
description: กฎบังคับในการอ้างอิง Skills ก่อนตอบคำถามทุกครั้ง
---
# กฎการอ้างอิง Skills

## กฎสำคัญ (บังคับ)
**ทุกครั้งที่ตอบคำถาม ต้องเข้าไปดูทักษะ (Skills) ในโฟลเดอร์ `antigravity-awesome-skills/skills` ก่อนเสมอ**

## ขั้นตอนการทำงาน

### 1. วิเคราะห์คำถามของผู้ใช้
- ทำความเข้าใจว่าผู้ใช้ต้องการอะไร
- ระบุหัวข้อหรือเทคโนโลยีที่เกี่ยวข้อง

### 2. ค้นหา Skills ที่เกี่ยวข้อง
```bash
# ดูรายการ Skills ทั้งหมด
ls antigravity-awesome-skills/skills/

# หรือค้นหา Skill เฉพาะทาง
find antigravity-awesome-skills/skills/ -type d -name "*keyword*"
```

### 3. อ่าน SKILL.md ของ Skill ที่เกี่ยวข้อง
- เปิดไฟล์ `SKILL.md` ในโฟลเดอร์ Skill ที่เลือก
- ศึกษาคำแนะนำและแนวทางปฏิบัติ

### 4. ตอบคำถามตามแนวทางใน Skills
- ใช้ความรู้จาก Skills ในการตอบ
- **ห้ามคิดเองและตอบเอง** โดยไม่อ้างอิง Skills

## Categories ของ Skills ที่สำคัญ

### UI/UX และ Frontend
- `ui-ux-pro-max` - สำหรับการออกแบบ UI/UX ระดับพรีเมียม
- `ui-ux-designer` - การออกแบบ UI/UX ทั่วไป
- `frontend-dev-guidelines` - แนวทางการพัฒนา Frontend
- `react-best-practices` - Best practices สำหรับ React
- `tailwind-design-system` - ระบบออกแบบด้วย Tailwind

### Backend และ Database
- `backend-dev-guidelines` - แนวทางการพัฒนา Backend
- `php-pro` - สำหรับ PHP/Laravel
- `database-design` - การออกแบบ Database
- `api-patterns` - รูปแบบการออกแบบ API

### Architecture และ Design Patterns
- `architecture` - สถาปัตยกรรมซอฟต์แวร์
- `architecture-patterns` - รูปแบบสถาปัตยกรรม
- `clean-code` - การเขียนโค้ดให้สะอาด

### Security
- `security-scanning-security-hardening` - การรักษาความปลอดภัย
- `api-security-best-practices` - ความปลอดภัย API

### DevOps และ Deployment
- `git-pushing` - การใช้ Git
- `github-workflow-automation` - GitHub Workflows
- `docker-expert` - Docker

## ข้อห้าม
1. ❌ ห้ามตอบคำถามโดยไม่ดู Skills ก่อน
2. ❌ ห้ามคิดเองและตอบเองโดยไม่อ้างอิง
3. ❌ ห้ามละเลยแนวทางที่ระบุใน Skills

## ตัวอย่างการใช้งาน

### เมื่อถูกถามเกี่ยวกับการปรับปรุง UI
```
1. ดู skill: ui-ux-pro-max
2. อ่าน SKILL.md และ resources ที่เกี่ยวข้อง
3. ทำตามแนวทางที่กำหนดใน skill
```

### เมื่อถูกถามเกี่ยวกับ Laravel/PHP
```
1. ดู skill: php-pro
2. ดู skill: backend-dev-guidelines
3. อ่าน SKILL.md และทำตาม
```
