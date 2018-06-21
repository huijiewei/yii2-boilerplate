import blank from '@admin/views/layouts/Blank'
import authLogin from '@admin/views/templates/auth/Login'

const routes = [
  {
    path: '/auth',
    component: blank,
    children: [
      {
        path: 'login',
        component: authLogin
      }
    ]
  }
]

export default routes
