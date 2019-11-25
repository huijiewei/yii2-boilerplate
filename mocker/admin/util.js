exports.authenticationCheck = function(req, res, success) {
  const clientId = req.get('X-Client-Id') || ''

  if (clientId === '') {
    return res.status(400).json({
      name: 'BadRequest',
      message: '无效的 Client Id，请刷新页面重新操作',
      code: 0,
      status: 400
    })
  }

  const accessToken = req.get('X-Access-Token') || ''

  if (accessToken !== 'bmq7tDtL5GqT9b64') {
    return res.status(401).json({
      name: 'Unauthorized',
      message: '必须登陆才能进行操作',
      code: 0,
      status: 401
    })
  }

  return success()
}

exports.notFoundCheck = function(item, message, res, success) {
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
