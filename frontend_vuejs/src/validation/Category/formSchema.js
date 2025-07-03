import * as yup from "yup";

export const formSchema = yup.object({
  name: yup.string().max(255).required("Name is required"),
  email: yup
    .string()
    .max(255)
    .required("Email is required")
    .email("Email is invalid"),
  phone: yup
    .string()
    .matches(/^(0|\+84)[0-9]{9,10}$/, "Phone number is invalid")
    .notRequired(),
});
