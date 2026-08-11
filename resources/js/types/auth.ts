export type User = App.Data.UserData

export type Auth = {
  user: User | null
}

export type TwoFactorConfigContent = {
  title: string
  description: string
  buttonText: string
}

export type Passkey = App.Data.PasskeyData
