<!-- Footer -->
<div class="footer">
    <div class="container">
        <a class="footer-link" href="mainpagefaq.php">FAQ</a>
        <a class="footer-link" href="contactus.php">Contact Us</a>
        <p class="footer-text">CypRIDE 2023</p>
        <img class="footer-logo" src="logo.png">
    </div>
</div>

<style>
    .footer {
    background-color: #fff;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px;
    position: absolute;
    bottom: 0;
    width: 100%;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
}

.footer-link {
    color: #000;
    line-height: 60px;
    margin-right: 10px;
    text-decoration: none;
}

.footer-text {
    color: #000;
    line-height: 60px;
    margin-left: auto;
    margin-right: 10px;
}

.footer-logo {
    height: 60px;
    margin-left: 10px;
}
@media (max-width: 768px) {
    .footer {
        flex-wrap: wrap;
        padding: 10px 20px;
    }

    .footer-link {
        width:60px;
        margin-right: 0;
        margin-bottom: 10px;
    }

    .footer-text {
        width: 60px;
        margin-left: 0;
        margin-right: 0;
        text-align: center;
    }

    .footer-logo {
        width: 100%;
        margin-left: 0;
        margin-right: auto;
    }
}
</style>