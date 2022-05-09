export default {
     columns: [
          {
            label: "ID",
            field: "id",
            width: "3%",
            sortable: true,
            isKey: true,
          },
          {
            label: "Nombre",
            field: "name",
            width: "15%",
            sortable: true,
          },
          {
            label: "Descripcion",
            field: "description",
            width: "15%",
            sortable: true,
          },
          {
            label: "Codigo",
            field: "code",
            width: "15%",
            sortable: true,
          },
          {
            label: "Precio",
            field: "price",
            width: "15%",
            sortable: true,
          },
          {
            label: "Categoria",
            field: "category_name",
            width: "15%",
            sortable: true,
          },
          {
            label: "Fecha de registro",
            field: "Formatted_created_at",
            width: "3%",
            sortable: false,
          },
          {
            label: "Acciones",
            field: "actions",
            width: "3%",
            sortable: false,
          },
          
        ],
}
      