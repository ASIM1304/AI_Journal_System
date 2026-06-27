import fitz

pdf = fitz.open("sample.pdf")

text = ""

for page in pdf:

    text += page.get_text()

print(text)