import fitz
import pymysql
from transformers import pipeline
from keybert import KeyBERT

# -----------------------------
# Database Connection
# -----------------------------
connection = pymysql.connect(
    host="localhost",
    user="root",
    password="",
    database="ai_journal_db"
)

cursor = connection.cursor()

# -----------------------------
# Get Latest Uploaded Paper
# -----------------------------
cursor.execute("""
SELECT paper_id, pdf_file
FROM papers
ORDER BY paper_id DESC
LIMIT 1
""")

paper = cursor.fetchone()

if paper is None:
    print("No papers found.")
    connection.close()
    exit()

paper_id = paper[0]
pdf_file = paper[1]

pdf_path = "../uploads/" + pdf_file

# -----------------------------
# Read PDF
# -----------------------------
pdf = fitz.open(pdf_path)

text = ""

for page in pdf:
    text += page.get_text()

pdf.close()

text = text[:3000]

# -----------------------------
# AI Summary
# -----------------------------
summarizer = pipeline(
    "summarization",
    model="sshleifer/distilbart-cnn-12-6"
)

summary = summarizer(
    text,
    max_length=150,
    min_length=50,
    do_sample=False
)

summary_text = summary[0]["summary_text"]

# -----------------------------
# Keyword Extraction
# -----------------------------
kw_model = KeyBERT()

keywords = kw_model.extract_keywords(
    text,
    keyphrase_ngram_range=(1,2),
    stop_words="english",
    top_n=10
)

keyword_list = []

for word in keywords:
    keyword_list.append(word[0])

keywords_text = ", ".join(keyword_list)

# -----------------------------
# AI Results
# -----------------------------
reading_time = str(len(text.split()) // 200 + 1) + " min"

predicted_domain = "Artificial Intelligence"

ai_score = 95

print("\nSummary\n")
print(summary_text)

print("\nKeywords\n")
print(keywords_text)

# -----------------------------
# Delete Old Analysis (if any)
# -----------------------------
cursor.execute(
    "DELETE FROM ai_analysis WHERE paper_id=%s",
    (paper_id,)
)

connection.commit()

# -----------------------------
# Save AI Analysis
# -----------------------------
sql = """
INSERT INTO ai_analysis
(
paper_id,
summary,
keywords,
predicted_domain,
reading_time,
ai_score
)
VALUES
(
%s,
%s,
%s,
%s,
%s,
%s
)
"""

values = (
paper_id,
summary_text,   
keywords_text,
predicted_domain,
reading_time,
ai_score
)

cursor.execute(sql, values)

connection.commit()

print("\nAI Analysis Saved Successfully")

connection.close()