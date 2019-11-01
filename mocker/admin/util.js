exports.authenticationCheck = function (req, res, success) {
  const authorization = req.get('Authorization') || ''

  const authorizationTokens = authorization.split(' ')

  const apiToken = authorizationTokens[1] || ''
  const userToken = authorizationTokens[2] || ''

  if (apiToken !== process.env.VUE_APP_ADMIN_API_TOKEN) {
    return res.status(400).json({
      name: 'BadRequest',
      message: '无效的 API TOKEN',
      code: 0,
      status: 400
    })
  }

  if (userToken !== 'bmq7tDtL5GqT9b64') {
    return res.status(401).json({
      name: 'Unauthorized',
      message: '必须登陆才能进行操作',
      code: 0,
      status: 401
    })
  }

  return success()
}

exports.notFoundCheck = function (item, message, res, success) {
  if (item === null) {
    return res.status(404).json({
      name: 'Not Found',
      message: message,
      code: 0,
      status: 404
    })
  } else {
    return success()
  }
}
