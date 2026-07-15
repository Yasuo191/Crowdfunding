import React from "react";
import ReactDOM from "react-dom/client";
import { AuthProvider } from "./context/AuthContext";
import { BrowserRouter } from "react-router-dom";
import "./styles/theme.css";
import App from "./App";  
import { Toaster } from "sonner";   
import "./styles/global.css";
ReactDOM.createRoot(document.getElementById("root")).render(
  <BrowserRouter>
    <AuthProvider>
      <App />
    </AuthProvider>
    <Toaster
      position="top-right"
      richColors
      closeButton
      duration={2500}
    />
  </BrowserRouter>
);
