const chokidar = require('chokidar')
const bodyParser = require('body-parser')
const path = require('path')

const mockDir = path.join(process.cwd(), 'mock')

function registerRoutes (app) {
  let mockLastIndex
  const mocks = require('./index.js')
  for (const mock of mocks) {
    app[mock.type](mock.url, mock.response)
    mockLastIndex = app._router.stack.length
  }
  const mockRoutesLength = Object.keys(mocks).length
  return {
    mockRoutesLength: mockRoutesLength,
    mockStartIndex: mockLastIndex - mockRoutesLength
  }
}

function unregisterRoutes () {
  Object.keys(require.cache).forEach(i => {
    if (i.includes(mockDir)) {
      delete require.cache[require.resolve(i)]
    }
  })
}

module.exports = app => {
  app.use(bodyParser.json())
  app.use(bodyParser.urlencoded({
    extended: true
  }))

  const mockRoutes = registerRoutes(app)
  let mockRoutesLength = mockRoutes.mockRoutesLength
  let mockStartIndex = mockRoutes.mockStartIndex

  chokidar.watch(mockDir, {
    ignored: /server/,
    ignoreInitial: true
  }).on('all', (event, path) => {
    if (event === 'change' || event === 'add') {
      try {
        app._router.stack.splice(mockStartIndex, mockRoutesLength)

        unregisterRoutes()

        const mockRoutes = registerRoutes(app)
        mockRoutesLength = mockRoutes.mockRoutesLength
        mockStartIndex = mockRoutes.mockStartIndex

        console.log(`\n > Mock Server hot reload success! changed  ${path}`)
      } catch (error) {
        console.error(error)
      }
    }
  })
}
