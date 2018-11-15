import React from "react";

const themeConstants = {
  windowSize: window.innerWidth,
};

export const ThemeContext = React.createContext(
  themeConstants
);