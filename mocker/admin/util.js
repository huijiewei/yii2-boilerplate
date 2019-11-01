exports.authenticationCheck = function (req, res, success) {
  const userToken = req.headers['x-user-token']

  if (userToken && userToken === 'bmq7tDtL5GqT9b64') {
    return success()
  } else {
    return res.status(401).json({
      name: 'Unauthorized',
      message: '必须登陆才能进行操作',
      code: 0,
      status: 401
    })
  }
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
