export function validatePassword(password) {
  const hasLetter = /[a-zA-Z]/.test(password);
  const hasSpecialChar = /[!@#$%^&*(),.?":{}|<>]/.test(password);

  if (!hasLetter && !hasSpecialChar) {
    return "Password must contain at least one letter and at least one special character";
  }
  if (password.length < 6) {
    return "Password must be at least 6 characters long";
  }
  return "";
}

function validateEmail(email) {
  return /^\S+@\S+\.\S+$/.test(email);
}

function validateName(name) {
  return name.trim().length > 0;
}

export function validateRegistrationForm(data) {
  if (!validateName(data.name)) {
    return "Name is required";
  }
  if (!validateEmail(data.email)) {
    return "Invalid email, it should be like 'test@gmail.com'";
  }
  const passwordError = validatePassword(data.password);
  if (passwordError) {
    return passwordError;
  }
  return "";
}
