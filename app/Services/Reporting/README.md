# Reporting Service Structure

This folder contains all the logic for generating and exporting reports. Here is a simple explanation of each folder:

-   **Builders**: Contains the "workers" that know how to build specific types of reports (e.g., Sales Report, Marketing Report).
-   **Contracts**: Defines the "rules" or interfaces that other classes must follow. It ensures consistency.
-   **Director**: The "manager" that tells the builders what to do. It orchestrates the report building process.
-   **DTOs (Data Transfer Objects)**: Simple objects used to carry data between different parts of the application.
-   **Enums**: Defines fixed lists of values, such as Report Status (e.g., Pending, Completed).
-   **Exports**: Handles the logic for saving reports in different formats like PDF or CSV.
-   **Factories**: Responsible for creating the right "Builder" based on the report type requested.
-   **Providers**: Connects this reporting service to the main Laravel application.
