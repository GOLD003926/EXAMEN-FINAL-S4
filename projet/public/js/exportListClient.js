console.log("Export List Client JS loaded");

const exportBtn = document.getElementById('exportBtn');

if (exportBtn) {
    exportBtn.addEventListener('click', function() {
        // Check if jsPDF is loaded
        if (typeof jsPDF === 'undefined') {
            // Load jsPDF dynamically
            const script = document.createElement('script');
            script.src = 'https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js';
            script.onload = function() {
                generatePDF();
            };
            document.head.appendChild(script);
        } else {
            generatePDF();
        }
    });
}

function generatePDF() {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF();
    
    // Get table data
    const table = document.querySelector('table');
    const rows = table.querySelectorAll('tbody tr');
    
    // Title
    doc.setFontSize(18);
    doc.text('Liste des Comptes Clients', 14, 22);
    
    // Date
    doc.setFontSize(10);
    doc.text(`Généré le: ${new Date().toLocaleDateString('fr-FR')}`, 14, 30);
    
    // Table headers
    doc.setFontSize(10);
    doc.setFont('helvetica', 'bold');
    doc.text('ID', 14, 45);
    doc.text('N° Compte', 30, 45);
    doc.text('Nom du Client', 70, 45);
    doc.text('Solde (Ar)', 140, 45);
    doc.text('Statut', 170, 45);
    
    // Table data
    doc.setFont('helvetica', 'normal');
    let y = 55;
    
    rows.forEach((row, index) => {
        if (y > 280) {
            doc.addPage();
            y = 20;
        }
        
        const cells = row.querySelectorAll('td');
        const id = cells[0].textContent.trim();
        
        // Remove icon span from account number
        const accountCell = cells[1].cloneNode(true);
        const iconSpan = accountCell.querySelector('.material-symbols-outlined');
        if (iconSpan) iconSpan.remove();
        const accountNumber = accountCell.textContent.trim();
        
        const clientName = cells[2].textContent.trim();
        const balance = cells[3].textContent.trim();
        const status = cells[4].textContent.trim();
        
        doc.text(id, 14, y);
        doc.text(accountNumber, 30, y);
        doc.text(clientName.substring(0, 25), 70, y);
        doc.text(balance, 140, y);
        doc.text(status, 170, y);
        
        y += 10;
    });
    
    // Save PDF
    doc.save('liste_comptes_clients.pdf');
}
