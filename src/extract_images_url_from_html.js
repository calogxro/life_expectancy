const fs = require('fs')
const path = require('path')
const cheerio = require('cheerio')

// > node this_command filename
const filename = process.argv[2]  // || 'document.html'

//filename = path.join(__dirname, filename)

// Read the file
const html = fs.readFileSync(filename, { encoding: 'utf8' });  //console.log(html)

const $ = cheerio.load(html)

// Iterate img tags
$('#principale .editor > p > img').each((i, el) => {
    console.log(el.attribs.src)
})

