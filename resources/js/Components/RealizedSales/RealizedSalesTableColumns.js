export default {
     columns: [
          {
            label: "Codigo venta",
            field: "id",
            width: "10%",
            sortable: true,
          },
          {
            label: "Vendedor",
            field: "user_name",
            width: "15%",
            sortable: true,
          },
          {
            label: "Sucursal",
            field: "branch_name",
            width: "15%",
            sortable: true,
          },
          {
            label: "Cliente",
            field: "customer_name",
            width: "15%",
            sortable: true,
          },
          {
            label: "Tipo de venta",
            field: "sale_type_name",
            width: "15%",
            sortable: true,
          },
          {
            label: "Metodo de pago",
            field: "payment_method_name",
            width: "15%",
            sortable: true,
          },
          {
            label: "Estado de venta",
            field: "sale_status_name",
            width: "15%",
            sortable: true,
          },
          {
            label: "Total de compra",
            field: "formatted_total_sale",
            width: "15%",
            sortable: true,
          },
          {
            label: "Fecha de registro",
            field: "Formatted_created_at",
            width: "3%",
            sortable: true,
          },
          {
            label: "Acciones",
            field: "actions",
            width: "10%",
            sortable: false,
          },
          
      ],
}
      