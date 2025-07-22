DROP TABLE IF EXISTS account_info;
CREATE TABLE account_info (
	account_id varchar(20) NOT NULL,
    account_pw varchar(20) NOT NULL,
    highest_balance int,
    PRIMARY KEY (account_id)
);