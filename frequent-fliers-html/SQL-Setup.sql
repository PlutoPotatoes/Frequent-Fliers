CREATE TABLE kiteEvent(
	eventID MEDIUMINT NOT NULL AUTO_INCREMENT,
	eventName CHAR(60) NOT NULL,
	startTime TIME,
	playerCount TINYINT,
	PRIMARY KEY (eventID)
	); 
	
CREATE TABLE QRCode(
	img BLOB NOT NULL,
	eventID MEDIUMINT NOT NULL,
	PRIMARY KEY (eventID),
	FOREIGN KEY (eventID) REFERENCES kiteEvent(eventID)
);

CREATE TABLE attendee(
	userID MEDIUMINT AUTO_INCREMENT,
	playerName CHAR(30) NOT NULL,
	email CHAR(60) NOT NULL,
	eventID MEDIUMINT NOT NULL,
	points SMALLINT,
	PRIMARY KEY (userID),
	CONSTRAINT event_FK FOREIGN KEY (eventID) REFERENCES kiteEvent(eventID)
);

CREATE TABLE eventMatch(
	eventID MEDIUMINT NOT NULL,
	attackSide CHAR(3) NOT NULL,
	matchNo TINYINT NOT NULL, 
	player1 MEDIUMINT NOT NULL,	
	player2 MEDIUMINT NOT NULL,
	player1Score TINYINT	DEFAULT 0,
	player2Score TINYINT	DEFAULT 0,
	startTime TIME NOT NULL,
	constraint event_pk PRIMARY KEY (eventID, matchNo),
	CONSTRAINT player1_fk FOREIGN KEY (player1) REFERENCES attendee(userID),
	CONSTRAINT player2_fk FOREIGN KEY (player2) REFERENCES attendee(userID),
	CONSTRAINT possible_attacks CHECK (attackSide= "top" OR attackSide = "bot")
	
	
	);
	



