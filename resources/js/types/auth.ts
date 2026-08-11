export type User = App.Data.UserData

export type Auth = {
  user: User | null
}

export type TwoFactorConfigContent = {
  title: string
  description: string
  buttonText: string
}

export type Passkey = {
  id: string
  name: string
  authenticator: string | null
  created_at_diff: string
  last_used_at_diff: string | null
}
