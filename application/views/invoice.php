<!-- Invoice Page (invoice.html) -->
<div class="container">
    <h2>Invoice #{{ invoice.id }}</h2>
    <p>Date: {{ invoice.date }}</p>
    <h3>Products Purchased</h3>
    <ul>
        <li v-for="item in invoice.items">{{ item.name }} - {{ item.quantity }} x {{ item.price | currency }}</li>
    </ul>
    <p>Total: {{ invoice.total | currency }}</p>
    <button @click="downloadInvoice(invoice.id)">Download Invoice</button>
</div>