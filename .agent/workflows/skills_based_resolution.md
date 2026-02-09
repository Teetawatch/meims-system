---
description: A mandatory workflow to resolve all user requests by first consulting the antigravity-awesome-skills/skills directory.
---

# Skill-Based Resolution Workflow

This workflow enforces the rule that all user requests must be answered by consulting the skills in `antigravity-awesome-skills/skills`.

## Steps

1.  **Analyze Request**: Understand the user's task or question.
2.  **Search Skills**:
    -   List or search the `antigravity-awesome-skills/skills` directory to find relevant skills.
    -   Use `list_dir` on `antigravity-awesome-skills/skills` or `grep_search` to find keywords matching the request.
3.  **Consult Skill**:
    -   Read the `SKILL.md` file of the most relevant skill(s) found.
    -   **CRITICAL**: Do not rely on internal knowledge if a skill exists. Follow the `SKILL.md` instructions exactly.
4.  **Execute**:
    -   Perform the task (coding, planning, debugging, etc.) following the steps outlined in the chosen skill.
    -   If the skill requires running scripts or specific tools, do so.
5.  **Fallback**:
    -   If no specific skill is found, use a general skill like `writing-plans`, `systematic-debugging`, or `senior-fullstack` as a baseline for high-quality output.
    -   **Never** answer without referencing a skill if at all possible.
