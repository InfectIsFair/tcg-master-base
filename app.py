from flask import Flask, render_template, url_for
import orderSetCSVByDate

def importCSV():
    returnList = []
    librarian = open('card-library.csv', 'r')
    for line in librarian.readlines():
        returnList.append(line.split(','))

    return returnList


def importSetCSV():
    returnList = []
    librarian = open("mtg-set.csv", "r")
    for line in librarian.readlines():
        returnList.append(line.split("/"))

    return returnList


orderSetCSVByDate.sortSets()

app = Flask(__name__)

cards = importCSV()
sets = importSetCSV()
cardsLength = len(cards)



@app.route('/')
def index():
    return render_template("index.html", cards=cards)

@app.route('/about/')
def about():
    return render_template("about.html", cards=cards)

@app.route('/contact-me/')
def contact():
    return render_template("contact.html", cards=cards)

@app.route('/tcg-master-base_<magic_set_img>-set.png/')
def MTGSetImage(magic_set_img):
    print(sets)
    for set in sets:
        if set[1] == magic_set_img:
            url_for('static', filename=sets[set[0] - 1][4])

@app.route('/magic-card-database/<magic_card_id>/')
def singleCards(magic_card_id):
    for card in cards:
        if card[0] == magic_card_id:
            return render_template("magic-card.html", value=card, setCSV=sets, cards=cards)
    

if __name__ == "__main__":
    app.run(debug=True)