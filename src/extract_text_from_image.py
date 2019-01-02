try:
    from PIL import Image
except ImportError:
    import Image
import pytesseract

import sys

filename = sys.argv[1]

print(pytesseract.image_to_string(Image.open(filename)))
