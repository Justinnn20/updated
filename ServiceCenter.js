document.addEventListener("DOMContentLoaded", () => {
    // --- 1. MOCK DATA ---
    let reservations = [
        { id: 1, status: 'Pending', time: '9:00', pax: 4, name: 'Annika Masongsong' },
        { id: 2, status: 'Pending', time: '10:00', pax: 2, name: 'Aliah Guinmapang' },
        { id: 3, status: 'Pending', time: '11:00', pax: 7, name: 'Patricia Mae Yasol' },
        { id: 4, status: 'Seated', time: '9:00', pax: 2, name: 'Justin Bieber' },
        { id: 5, status: 'Seated', time: '10:00', pax: 4, name: 'Kim Jennie' }
    ];

    let pendingReviews = [
        { id: 101, name: 'Annika Masongsong', rating: 5, text: 'Best adobo ever!' },
        { id: 102, name: 'Patricia Mae Yasol', rating: 5, text: 'Best restaurant!' }
    ];

    let publishedReviews = [];

    let inquiries = [
        { id: 201, sender: 'Annika Masongsong', subject: 'Place Rental', date: '04/17/26', message: 'Hello, I\'m here to inquire about renting your place for a birthday.' },
        { id: 202, sender: 'Patricia Mae Yasol', subject: 'Staff Complaint', date: '04/17/26', message: 'The wait time was a bit long earlier.' },
        { id: 203, sender: 'Aliah Guinmapang', subject: 'Job Application', date: '04/17/26', message: 'Are you still hiring for kitchen staff?' }
    ];

    // --- 2. RESERVATION FUNCTIONS ---
    window.renderReservations = (filterStatus = 'All') => {
        const list = document.getElementById("reservation-list");
        list.innerHTML = "";
        const filtered = filterStatus === 'All' ? reservations : reservations.filter(r => r.status === filterStatus);

        filtered.forEach(res => {
            const row = document.createElement("tr");
            row.innerHTML = `
                <td><span class="status-pill ${res.status.toLowerCase()}" onclick="toggleSeated(${res.id})" style="cursor:pointer">${res.status}</span></td>
                <td>${res.time}</td>
                <td><i class="fa-solid fa-user"></i> ${res.pax}</td>
                <td>${res.name}</td>
            `;
            list.appendChild(row);
        });
    };

    window.filterReservations = (status) => renderReservations(status);

    window.toggleSeated = (id) => {
        const res = reservations.find(r => r.id === id);
        res.status = res.status === 'Pending' ? 'Seated' : 'Pending';
        renderReservations();
    };

    // --- 3. FEEDBACK FUNCTIONS ---
    window.renderFeedback = () => {
        const queue = document.getElementById("feedback-queue");
        const grid = document.getElementById("published-grid");
        queue.innerHTML = ""; grid.innerHTML = "";

        pendingReviews.forEach((rev, index) => {
            queue.innerHTML += `
                <div class="review-card">
                    <div class="review-user">
                        <div class="user-avatar"><i class="fa-solid fa-user"></i></div>
                        <div><h5>${rev.name}</h5><div class="stars">${'★'.repeat(rev.rating)}</div></div>
                    </div>
                    <p class="review-comment">"${rev.text}"</p>
                    <div class="review-actions">
                        <button class="btn-approve" onclick="approveReview(${index})">Approve</button>
                        <button class="btn-decline" onclick="deleteReview(${index})">Decline</button>
                    </div>
                </div>`;
        });

        publishedReviews.forEach(rev => {
            grid.innerHTML += `
                <div class="mini-card">
                    <div class="stars">${'★'.repeat(rev.rating)}</div>
                    <p><b>${rev.name}</b></p>
                    <p><i>"${rev.text}"</i></p>
                </div>`;
        });
    };

    window.approveReview = (index) => {
        publishedReviews.push(pendingReviews[index]);
        pendingReviews.splice(index, 1);
        renderFeedback();
    };

    window.deleteReview = (index) => {
        pendingReviews.splice(index, 1);
        renderFeedback();
    };

    // --- 4. INBOX FUNCTIONS ---
    window.renderInquiries = () => {
        const list = document.getElementById("inquiry-list");
        const badge = document.getElementById("inbox-badge");
        list.innerHTML = "";
        badge.innerText = `${inquiries.length} new`;

        inquiries.forEach((inq, index) => {
            const row = document.createElement("tr");
            row.style.cursor = "pointer";
            row.onclick = () => selectInquiry(index);
            row.innerHTML = `
                <td>${inq.sender}</td>
                <td>${inq.subject}</td>
                <td>${inq.date}</td>
                <td>Pending</td>
            `;
            list.appendChild(row);
        });
    };

    let selectedInquiryIndex = null;
    window.selectInquiry = (index) => {
        selectedInquiryIndex = index;
        const inq = inquiries[index];
        document.getElementById("reply-subject").value = inq.subject;
        document.getElementById("customer-inquiry").value = inq.message;
        document.getElementById("admin-reply").value = "";
    };

    window.sendAdminReply = () => {
        const reply = document.getElementById("admin-reply").value;
        if (!reply || selectedInquiryIndex === null) {
            alert("Pili ka muna ng message at mag-type ng reply, Kabayan!");
            return;
        }
        alert("Reply sent to " + inquiries[selectedInquiryIndex].sender);
        inquiries.splice(selectedInquiryIndex, 1); // Remove from inbox after reply
        selectedInquiryIndex = null;
        document.getElementById("reply-subject").value = "";
        document.getElementById("customer-inquiry").value = "";
        document.getElementById("admin-reply").value = "";
        renderInquiries();
    };

    // Initial Launch
    renderReservations();
    renderFeedback();
    renderInquiries();
});