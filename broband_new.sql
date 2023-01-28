CREATE TABLE useraccount (
    id INT NOT NULL AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    address VARCHAR(255) NOT NULL,
    phone BIGINT NOT NULL,
		PRIMARY KEY (id),
		UNIQUE (phone)
);

CREATE TABLE ulogin (
    user_id INT NOT NULL,
    phone BIGINT NOT NULL,
    password VARCHAR(255) NOT NULL,
		PRIMARY KEY(user_id,phone)
);

CREATE TABLE internet_plans (
    id INT NOT NULL AUTO_INCREMENT,
    plan_name VARCHAR(255) NOT NULL,
    details JSON NOT NULL,
    internet_speed INT NOT NULL,
    cost BIGINT NOT NULL,
    fup_limit BIGINT NOT NULL,
    min_first_bill_period ENUM('1m','3m','6m') NOT NULL,
		PRIMARY KEY(id)
);

CREATE TABLE services(
    id INT NOT NULL AUTO_INCREMENT,
    service_name VARCHAR(255) NOT NULL,
    cost BIGINT NOT NULL,
		PRIMARY KEY(id)
);

CREATE TABLE bills(
    bill_id INT NOT NULL AUTO_INCREMENT,
    user_id INT NOT NULL,
    amount BIGINT NOT NULL,
    due_date TIMESTAMP NOT NULL,
    paid_date TIMESTAMP NULL,
    related_service INT NULL,
    related_plan INT NULL,
		offer_id INT NULL,
    cgst_percentage DOUBLE NOT NULL,
    sgst_percentage DOUBLE NOT NULL,
		PRIMARY KEY(bill_id)
);

CREATE TABLE user_plan_tracker(
    user_id INT NOT NULL,
    plan_id INT NOT NULL,
		purchase_bill INT NOT NULL,
    date_of_purchase TIMESTAMP NOT NULL,
		FOREIGN KEY(purchase_bill) REFERENCES bills(bill_id)
);

CREATE TABLE user_service_tracker(
    user_id BIGINT NOT NULL,
    service_id BIGINT NOT NULL,
    service_period VARCHAR(255) NULL,
		purchase_bill INT NOT NULL,
    date_of_purchase TIMESTAMP NOT NULL,
		FOREIGN KEY(purchase_bill) REFERENCES bills(bill_id)
);

CREATE TABLE offers(
    id INT NOT NULL AUTO_INCREMENT,
    offer_name VARCHAR(255) NOT NULL,
    discount_amount BIGINT NOT NULL,
    validity DATE NOT NULL,
		PRIMARY KEY(id)
);

ALTER TABLE
    ulogin ADD CONSTRAINT ulogin_user_id_foreign FOREIGN KEY(user_id) REFERENCES useraccount(id);
ALTER TABLE
    ulogin ADD CONSTRAINT ulogin_phone_foreign FOREIGN KEY(phone) REFERENCES useraccount(phone);

ALTER TABLE
    user_plan_tracker ADD CONSTRAINT user_plan_tracker_user_id_foreign FOREIGN KEY(user_id) REFERENCES useraccount(id);
ALTER TABLE
    user_plan_tracker ADD CONSTRAINT user_plan_tracker_plan_id_foreign FOREIGN KEY(plan_id) REFERENCES internet_plans(id);
ALTER TABLE
    bills ADD CONSTRAINT bills_user_id_foreign FOREIGN KEY(user_id) REFERENCES useraccount(id);
ALTER TABLE
    bills ADD CONSTRAINT bills_related_service_foreign FOREIGN KEY(related_service) REFERENCES services(id);
ALTER TABLE
    bills ADD CONSTRAINT bills_related_plan_foreign FOREIGN KEY(related_plan) REFERENCES internet_plans(id);
